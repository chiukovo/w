<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Article;

class GenerateArticleCommand extends Command
{
    protected $signature = 'generate:article';
    protected $description = '使用 GPT-4o-mini 自動產生帶有樣式的 HTML 文章';

    public function handle()
    {
        $this->info('🚀 呼叫 GPT-4o-mini 生成分類 & 文章...');

        // 1. 自動生成分類 + 標題
        $topicPrompt = [
            ['role' => 'system', 'content' => '你是一位懂得吸引用戶眼球的台灣彩券部落客。'],
            ['role' => 'user', 'content' => "
        針對「威力彩、大樂透、今彩539、雙贏彩」這些台灣彩券，請：
        1. 隨機選一個彩券作為類別。
        2. 幫該類別想一個<strong>吸引點擊的、富有情緒、具行動感</strong>的部落格標題，語氣大膽，不要制式，適合社群分享。
        
        請以「分類: [分類] | 標題: [吸睛標題+emoji]」格式回應。
        "]
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
        $title = $matches[2] ?? '未命名文章';

        $articlePrompt = [
            ['role' => 'system', 'content' => '你是一位懂得吸引人眼球的台灣彩券專業部落客，擅長寫出讓人想馬上點擊的文章，語氣活潑有梗。'],
            ['role' => 'user', 'content' => "
        針對「{$title}」這個主題，請撰寫一篇完整、有趣、故事感強的部落格文章，請依下列要求生成：
        
        1. 字數約 2000 字，內容要豐富、可讀性高，能吸引讀者一路看完。
        2. 使用純 HTML 結構，無需 <html> <body>。
        3. 整體排版結構：
           - <h2 class='text-3xl font-bold text-blue-700 mb-6 flex items-center gap-2'> 主標題，語氣要大膽、吸睛、有趣，帶 emoji，避免制式（如「威力彩冷號分析」）。
           - <p class='mb-5 text-gray-700 leading-relaxed'> 段落語氣輕鬆、故事性強，有舉例、笑點或彩迷經驗分享，多穿插 emoji。
           - <h3 class='text-xl font-semibold mb-3 mt-6 flex items-center gap-2'> 小標題也要吸引人，帶 emoji，避免單調。
           - <ul> 重點列表，搭配 emoji 與輕鬆口吻描述。
           - 中間加入 1~2 段「小故事」或「真實案例」，例如彩迷朋友買彩券的經驗、幸運號碼的都市傳說。
           - 統計數據要用「輕鬆解說」的方式寫出，例如「去年8號熱到爆，中了150次！💥」。
           - 必須加上 1~2 個「溫馨提示區塊」或「冷知識小卡片」，格式為 <div class='bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded mb-5 text-sm text-yellow-800 flex items-center gap-2'> 💡 ...</div>。
        4. 文章語氣活潑，能像朋友對話，適合台灣人閱讀，請多用「你知道嗎？」「朋友們～」「彩迷常犯的錯誤是？」等句式。
        5. 結尾請用「祝大家好運 🍀 並記得理性投注喔😉！」作為收尾，留有親切感。
        6. 去除 ```html 或 ``` 這類區塊符號，直接回傳 HTML。
        
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
                'slug' => Str::slug($title) . '-' . time(),
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
