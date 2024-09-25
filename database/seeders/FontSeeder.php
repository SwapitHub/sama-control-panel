<?php

namespace Database\Seeders;
use App\Models\Font;
use Illuminate\Database\Seeder;

class FontSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fonts = [
            ['value' => 'ℋ𝒶𝓇𝓇𝒾𝓃ℊ𝓉ℴ𝓃', 'label' => 'ℋ𝒶𝓇𝓇𝒾𝓃ℊ𝓉ℴ𝓃'],
            ['value' => 'ℒ𝓊𝒸𝒾𝒹𝒶 𝒞𝒶𝓁𝓁𝒾𝑔𝓇𝒶𝓅𝒽𝓎', 'label' => 'ℒ𝓊𝒸𝒾𝒹𝒶 𝒞𝒶𝓁𝓁𝒾𝑔𝓇𝒶𝓅𝒽𝓎'],
            ['value' => '𝔉𝔯𝔢𝔢𝔰𝔱𝔶𝔩𝔢 𝔖𝔠𝔯𝔦𝔭𝔱', 'label' => '𝔉𝔯𝔢𝔢𝔰𝔱𝔶𝔩𝔢 𝔖𝔠𝔯𝔦𝔭𝔱'],
            ['value' => '𝓢𝓬𝓻𝓲𝓹𝓽 𝓜𝓣 𝓑𝓸𝓵𝓭', 'label' => '𝓢𝓬𝓻𝓲𝓹𝓽 𝓜𝓣 𝓑𝓸𝓵𝓭'],
            ['value' => '𝚃𝚒𝚖𝚎𝚜 𝙽𝚎𝚠 𝚁𝚘𝚖𝚊𝚗', 'label' => '𝚃𝚒𝚖𝚎𝚜 𝙽𝚎𝚠 𝚁𝚘𝚖𝚊𝚗'],
            ['value' => '𝕽𝖆𝖌𝖊 𝕴𝖙𝖆𝖑𝖎𝖈', 'label' => '𝕽𝖆𝖌𝖊 𝕴𝖙𝖆𝖑𝖎𝖈'],
            ['value' => '𝕴𝖓𝖋𝖔𝖗𝖒𝖆𝖑 𝕽𝖔𝖒𝖆𝖓', 'label' => '𝕴𝖓𝖋𝖔𝖗𝖒𝖆𝖑 𝕽𝖔𝖒𝖆𝖓'],
            ['value' => '𝐻𝑒𝓁𝓋𝑒𝓉𝒾𝒸𝒶', 'label' => '𝐻𝑒𝓁𝓋𝑒𝓉𝒾𝒸𝒶'],
        ];

        foreach ($fonts as $font) {
            Font::create($font);
        }
    }
}
