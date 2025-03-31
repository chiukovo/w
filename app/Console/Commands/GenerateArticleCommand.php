<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Article;
use Illuminate\Support\Env;

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
        // 1. 擷取 Google News
        $searchResults = Http::get('https://news.google.com/rss/search?q=彩券+台灣&hl=zh-TW&gl=TW&ceid=TW:zh-Hant');
        $xml = simplexml_load_string($searchResults->body());
    
        $hotNews = [];
        foreach ($xml->channel->item as $item) {
            $hotNews[] = (string) $item->title;
        }
        shuffle($hotNews);
        $sampleNews = array_slice($hotNews, 0, rand(1, 3));
        $newsStr = implode("\n- ", $sampleNews);
        
        // 2. 產生文章標題（含分類 + 中文標題 + 英文標題，使用 JSON 回傳）
        $topicPrompt = [
            ['role' => 'system', 'content' => '你是一位懂得吸引用戶眼球的台灣彩券部落客。'],
            ['role' => 'user', 'content' => "請根據以下台灣彩券新聞，產生一組吸睛的部落格文章資訊，回傳 JSON 格式如下：\n{\n  \"category\": \"分類\",\n  \"title\": \"中文標題 + emoji\",\n  \"title_en\": \"英文 SEO 標題\"\n}\n\n- {$newsStr}"]
        ];

        $topicResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => $topicPrompt,
            'max_tokens' => 300,
            'temperature' => 0.7,
        ]);

        $output = trim($topicResponse['choices'][0]['message']['content'] ?? '');
        $output = preg_replace('/^```json|```$/i', '', $output); // 去除 GPT 回傳的 markdown 包裝
        $json = json_decode($output, true);

        $category = $json['category'] ?? '彩券綜合';
        $title = $json['title'] ?? '未命名文章';
        $title_en = $json['title_en'] ?? 'lottery-ai-income';
    
        // 3. 搜尋橫幅圖片（用英文標題搜尋 + 亂數抽圖）
        $query = $title_en;
        $apiKey = env('PEXELS_API_Key');
        $url = 'https://api.pexels.com/v1/search?query=' . urlencode($query) . '&per_page=10';
    
        $response = Http::withHeaders([
            'Authorization' => $apiKey
        ])->get($url);
    
        $data = $response->json();
        $bannerImages = collect($data['photos'] ?? [])->pluck('src')->map(fn($src) => $src['landscape'])->filter()->shuffle()->values()->all();
    
        // 4. 產生文章內容（HTML + 插圖段落）
        $articlePrompt = [
            ['role' => 'system', 'content' => '你是一位懂得吸引人眼球的台灣彩券專業部落客，擅長寫出讓人想馬上點擊的文章，語氣活潑有梗。'],
            ['role' => 'user', 'content' => "\n針對「{$title}」這個主題，請撰寫一篇完整、有趣、故事感強的部落格文章，請依下列要求生成：\n1. 字數約 2000 字，內容要豐富，排版不用太緊湊、可讀性高，能吸引讀者一路看完。\n2. 使用純 HTML 結構，無需 <html> <body>。\n3. 整體排版結構：\n   - <p class='mb-5 text-gray-700 leading-relaxed'> 段落語氣輕鬆、故事性強，有舉例、笑點或彩迷經驗分享，多穿插 emoji。\n   - <h3 class='text-xl font-semibold mb-3 mt-6 flex items-center gap-2'> 小標題也要吸引人，帶 emoji，避免單調。\n   - <ul> 重點列表，搭配 emoji 與輕鬆口吻描述。\n   - 中間加入 1~2 段「小故事」或「真實案例」，例如彩迷朋友買彩券的經驗、幸運號碼的都市傳說。\n   - 統計數據要用「輕鬆解說」的方式寫出，需是真實數據。\n   - 必須加上 1~2 個「溫馨提示區塊」或「冷知識小卡片」，格式為 <div class='bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded mb-5 text-sm text-yellow-800 flex items-center gap-2'> 💡 ...</div>。\n4. 同時請融合彩券 SEO 熱門詞，例如：『威力彩模擬』、『頭獎機率』、『今彩539開獎結果』，自然穿插在段落中。\n5. 文章語氣活潑，能像朋友對話，適合台灣人閱讀，請多用「你知道嗎？」「朋友們～」「彩迷常犯的錯誤是？」等句式。\n6. 結尾請用「祝大家好運 🍀 並記得理性投注喔😉！」作為收尾，留有親切感。\n7. 去除 ```html 或 ``` 這類區塊符號，直接回傳 HTML。\n8. 請仔細思考文章內容，確保有趣、有料，產生使用者會回訪的優質文章。"]
        ];
    
        $articleResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => $articlePrompt,
            'max_tokens' => 2000,
            'temperature' => 0.7,
        ]);
    
        $content = trim($articleResponse['choices'][0]['message']['content'] ?? '');
    
        // 5. 多圖穿插插入文章內容中
        if ($content && count($bannerImages)) {
            preg_match_all('/<h3[^>]*>/', $content, $matches, PREG_OFFSET_CAPTURE);
            $positions = $matches[0] ?? [];
    
            foreach ($positions as $i => [$tag, $offset]) {
                if (!isset($bannerImages[$i])) break;
                $imgTag = "<img src='{$bannerImages[$i]}' alt='{$title}' style='max-width:100%;margin:20px 0;'>";
                $insertPos = strpos($content, $tag, $offset);
                $content = substr_replace($content, $imgTag . $tag, $insertPos, strlen($tag));
            }
        }
    
        // 6. 儲存文章
        if ($content) {
            Article::create([
                'title' => $title,
                'slug' => Str::slug($title_en . '-' . now()->timestamp),
                'content' => $content,
                'category' => $category,
                'is_published' => true,
                'published_at' => now(),
            ]);
    
            $this->info("✅ 成功產出 【{$category}】 文章：《{$title}》");
        } else {
            $this->error('❌ GPT API 生成失敗');
        }
    }    
}
