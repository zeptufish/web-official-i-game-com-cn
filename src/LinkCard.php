<?php

/**
 * Generates a safe, escaped HTML card for a link.
 * Designed for embedding in GitHub README or other static contexts.
 */
class LinkCardRenderer
{
    /**
     * @var string The target URL for the card.
     */
    private string $url;

    /**
     * @var string The title or keyword for the card.
     */
    private string $title;

    /**
     * @var string A brief description, can be empty.
     */
    private string $description;

    /**
     * @var string Optional CSS class for the card container.
     */
    private string $cssClass;

    /**
     * @param string $url         The link URL.
     * @param string $title       The card title/keyword.
     * @param string $description Optional short description.
     * @param string $cssClass    Optional CSS class name.
     */
    public function __construct(
        string $url,
        string $title,
        string $description = '',
        string $cssClass = 'link-card'
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->cssClass = $cssClass;
    }

    /**
     * Set a new CSS class.
     *
     * @param string $cssClass
     * @return void
     */
    public function setCssClass(string $cssClass): void
    {
        $this->cssClass = $cssClass;
    }

    /**
     * Build an escaped HTML block for the link card.
     *
     * @return string Sanitized HTML string.
     */
    public function render(): string
    {
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDesc = htmlspecialchars($this->description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedClass = htmlspecialchars($this->cssClass, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $html = '<div class="' . $escapedClass . '">' . "\n";
        $html .= '    <a href="' . $escapedUrl . '" target="_blank" rel="noopener noreferrer">' . "\n";
        $html .= '        <span class="card-title">' . $escapedTitle . '</span>' . "\n";
        if ($escapedDesc !== '') {
            $html .= '        <span class="card-description">' . $escapedDesc . '</span>' . "\n";
        }
        $html .= '    </a>' . "\n";
        $html .= '</div>' . "\n";

        return $html;
    }

    /**
     * Static factory: create a simple card with keyword and default description.
     *
     * @param string $url     Target URL.
     * @param string $keyword Core keyword.
     * @return self
     */
    public static function createWithKeyword(string $url, string $keyword): self
    {
        $description = 'Discover more about ' . $keyword . ' at the official site.';
        return new self($url, $keyword, $description);
    }
}

// --- Example usage ---
// This block demonstrates how to use the class with the provided URL and keyword.
// It is safe and does not perform any network requests or external calls.

$url = 'https://web-official-i-game.com.cn';
$keyword = '爱游戏';

$card = LinkCardRenderer::createWithKeyword($url, $keyword);
echo $card->render();

// Additional example: custom description
$customCard = new LinkCardRenderer(
    $url,
    $keyword,
    'Your gateway to the world of ' . $keyword . '.'
);
echo $customCard->render();