<?php declare(strict_types=1);

namespace ZanBaldwin\DPC19\Obfuscation;

class ObfuscatingTransformFilter extends \php_user_filter
{
    // The "encryption" key used by GitHub Enterprise. See:
    // http://blog.orange.tw/2017/01/bug-bounty-github-enterprise-sql-injection.html
    private const KEY = 'This obfuscation is intended to discourage GitHub Enterprise customers from making modifications to the VM. We know this \'encryption\' is easily broken.';
    private const PREAMBLE = "<?php exit('Source Code Protected'); ?>\n\n";
    private const LINE_LENGTH = 80;

    /** @var string $input */
    private $input = '';

    public static function register(string $filterName): void
    {
        stream_filter_register($filterName, static::class);
    }

    public function filter($in, $out, &$consumed, $closing): int
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            $this->input .= $bucket->data;
        }
        if ($closing || feof($this->stream)) {
            $consumed = strlen($this->input);
            $bucket = stream_bucket_new(
                $this->stream,
                $this->decrypt($this->input)
            );
            stream_bucket_append($out, $bucket);
            return \PSFS_PASS_ON;
        }
        return \PSFS_FEED_ME;
    }

    // Decrypt
    public function decrypt(string $sourceCode): string
    {
        return strpos($sourceCode, static::PREAMBLE) === 0
            ? $this->xorStringWithKey(base64_decode(str_replace(
                "\n",
                '',
                substr($sourceCode, strlen(static::PREAMBLE))
            )))
            : $sourceCode;
    }

    // Encrypt
    public function encrypt(string $sourceCode): string
    {
        return static::PREAMBLE . implode("\n", str_split(
            base64_encode($this->xorStringWithKey($sourceCode)),
            static::LINE_LENGTH
        ));
    }

    private function xorStringWithKey(string $sourceCode): string
    {
        $length = strlen($sourceCode);
        for ($i = 0; $i < $length; $i++) {
            $sourceCode[$i] = $sourceCode[$i] ^ static::KEY[$i % strlen(static::KEY)];
        }
        return $sourceCode;
    }
}
