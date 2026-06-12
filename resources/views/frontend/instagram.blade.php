{{-- resources/views/instagram.blade.php --}}

<style>
    .insta-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 3px;
        max-width: 600px;
        margin: 0 auto;
    }
    .insta-post {
        position: relative;
        aspect-ratio: 1;
        overflow: hidden;
        display: block;
    }
    .insta-post img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    .insta-post:hover img { transform: scale(1.05); }
    .insta-post .overlay {
        position: absolute; inset: 0;
        background: rgba(0,0,0,0.4);
        display: flex; align-items: center;
        justify-content: center; gap: 12px;
        color: white; font-weight: bold;
        opacity: 0; transition: opacity 0.2s;
    }
    .insta-post:hover .overlay { opacity: 1; }
    .badge {
        position: absolute; top: 6px; right: 6px;
        background: rgba(0,0,0,0.6);
        color: white; font-size: 11px;
        padding: 2px 6px; border-radius: 4px;
    }
</style>

<div class="insta-grid">
    @forelse($posts as $post)
        <a class="insta-post" href="{{ $post['permalink'] }}" target="_blank">

            <img
                src="{{ $post['sizes']['medium']['mediaUrl'] ?? $post['mediaUrl'] }}"
                alt="{{ $post['prunedCaption'] ?? 'Instagram post' }}"
                loading="lazy"
            />

            @if($post['isReel'] ?? false)
                <span class="badge">▶ Reel</span>
            @elseif($post['mediaType'] === 'CAROUSEL_ALBUM')
                <span class="badge">❐</span>
            @endif

            <div class="overlay">
                <span>❤️ {{ $post['likeCount'] ?? 0 }}</span>
                <span>💬 {{ $post['commentsCount'] ?? 0 }}</span>
            </div>

        </a>
    @empty
        <p style="color:#888; padding:20px;">Koi post nahi mili.</p>
    @endforelse
</div>
