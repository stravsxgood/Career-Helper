<?php

namespace App\Services;

use Smalot\PdfParser\Parser;

class PdfTextExtractorService
{
    public function extract(string $filePath): string
    {
        $parser = new Parser();

        $pdf = $parser->parseFile($filePath);

        $text = trim($pdf->getText());

        if ($text === '') {
            throw new \Exception(
                'Teks CV tidak terbaca. Kemungkinan PDF berupa scan/gambar, bukan PDF teks.'
            );
        }

        return $text;
    }
}
