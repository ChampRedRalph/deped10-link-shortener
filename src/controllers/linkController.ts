class LinkController {
    private links: { [key: string]: string } = {};

    createLink(originalUrl: string): string {
        const shortUrl = this.generateShortUrl(originalUrl);
        this.links[shortUrl] = originalUrl;
        return shortUrl;
    }

    getLink(shortUrl: string): string | null {
        return this.links[shortUrl] || null;
    }

    deleteLink(shortUrl: string): boolean {
        if (this.links[shortUrl]) {
            delete this.links[shortUrl];
            return true;
        }
        return false;
    }

    private generateShortUrl(originalUrl: string): string {
        return Math.random().toString(36).substring(2, 8);
    }
}

export default LinkController;