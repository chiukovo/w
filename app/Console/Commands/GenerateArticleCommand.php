<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Article;

class GenerateArticleCommand extends Command
{
    protected $signature = 'generate:article {--count=}';
    protected $description = '使用 GPT-4o-mini 自動產生帶有樣式的 HTML 文章';

    public function handle()
    {
        $count = $this->option('count') ?? 5;
        $this->info('🚀 呼叫 GPT-4o-mini 生成分類 & 文章...');

        for ($i = 0; $i < $count; $i++) {
            $this->generateArticle();
        }
    }

    private function generateArticle()
    {
        // 取得 Google News
        $searchResults = Http::get('https://news.google.com/rss/search?q=彩券+台灣&hl=zh-TW&gl=TW&ceid=TW:zh-Hant');
        $xml = simplexml_load_string($searchResults->body());
    
        // 隨機取 3~5 則新聞
        $hotNews = [];
        foreach ($xml->channel->item as $item) {
            $hotNews[] = (string) $item->title;
        }
        shuffle($hotNews);
        $sampleNews = array_slice($hotNews, 0, rand(1, 3));
    
        // 組合成 prompt
        $newsStr = implode("\n- ", $sampleNews);
    
        $topicPrompt = [
            ['role' => 'system', 'content' => '你是一位懂得吸引用戶眼球的台灣彩券部落客。'],
            ['role' => 'user', 'content' => "
        根據以下台灣最新時事，結合「威力彩、大樂透、今彩539、雙贏彩」其中一個彩券，幫我想一個主題風格多變、吸睛又有社群話題感的部落格標題。
    
        並在內容中，請同時考慮 SEO，加入台灣常用的彩券熱門搜尋詞，如：『彩券頭獎機率』『威力彩模擬』『539開獎號碼』『樂透統計』『大樂透中獎率』。
    
        以下是今日台灣新聞：
        - {$newsStr}
    
        格式請為：「分類: [分類] | 標題: [吸睛標題+emoji]」"]
        ];
    
        $topicResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => $topicPrompt,
            'max_tokens' => 100,
            'temperature' => 0.7,
        ]);
    
        $output = trim($topicResponse['choices'][0]['message']['content'] ?? '');
        preg_match('/分類: (.*?) \| 標題: (.*)/', $output, $matches);
        $category = $matches[1] ?? '彩券綜合';
        $category = str_replace(['[', ']'], '', $category);
        $title = $matches[2] ?? '未命名文章';
    
        $articlePrompt = [
            ['role' => 'system', 'content' => '你是一位懂得吸引人眼球的台灣彩券專業部落客，擅長寫出讓人想馬上點擊的文章，語氣活潑有梗。'],
            ['role' => 'user', 'content' => "
        針對「{$title}」這個主題，請撰寫一篇完整、有趣、故事感強的部落格文章，請依下列要求生成：
        1. 字數約 2000 字，內容要豐富，排版不用太緊湊、可讀性高，能吸引讀者一路看完。
        2. 使用純 HTML 結構，無需 <html> <body>。
        3. 整體排版結構：
           - <p class='mb-5 text-gray-700 leading-relaxed'> 段落語氣輕鬆、故事性強，有舉例、笑點或彩迷經驗分享，多穿插 emoji。
           - <h3 class='text-xl font-semibold mb-3 mt-6 flex items-center gap-2'> 小標題也要吸引人，帶 emoji，避免單調。
           - <ul> 重點列表，搭配 emoji 與輕鬆口吻描述。
           - 中間加入 1~2 段「小故事」或「真實案例」，例如彩迷朋友買彩券的經驗、幸運號碼的都市傳說。
           - 統計數據要用「輕鬆解說」的方式寫出，例如「去年8號熱到爆，中了150次！💥」。
           - 必須加上 1~2 個「溫馨提示區塊」或「冷知識小卡片」，格式為 <div class='bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded mb-5 text-sm text-yellow-800 flex items-center gap-2'> 💡 ...</div>。
        4. 同時請融合彩券 SEO 熱門詞，例如：『威力彩模擬』、『頭獎機率』、『今彩539開獎結果』，自然穿插在段落中。
        5. 文章語氣活潑，能像朋友對話，適合台灣人閱讀，請多用「你知道嗎？」「朋友們～」「彩迷常犯的錯誤是？」等句式。
        6. 結尾請用「祝大家好運 🍀 並記得理性投注喔😉！」作為收尾，留有親切感。
        7. 去除 ```html 或 ``` 這類區塊符號，直接回傳 HTML。
        8. 請仔細思考文章內容，確保有趣、有料，產生使用者會回訪的優質文章。
        "]
        ];
    
        $articleResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => $articlePrompt,
            'max_tokens' => 1800,
            'temperature' => 0.7,
        ]);
    
        $content = trim($articleResponse['choices'][0]['message']['content'] ?? '');
    
        if ($content) {
            Article::create([
                'title' => $title,
                'slug' => time() + rand(100, 10000),
                'content' => $content,
                'category' => $category,
                'is_published' => true,
                'published_at' => now(),
            ]);
    
            // Sitemap ping
            Http::get('https://www.google.com/ping?sitemap=' . urlencode(url('/sitemap.xml')));
    
            $this->info("✅ 成功產出 【{$category}】 文章：《{$title}》，已通知 Google sitemap");
        } else {
            $this->error('❌ GPT API 生成失敗');
        }
    }
    
}
