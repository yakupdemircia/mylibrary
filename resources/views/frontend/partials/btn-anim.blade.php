{{-- btn anim --}}
<div @if(isset($id) && !empty($id)) id="{{ $id }}" @endif class="btn-anim {{ $class ?? "" }}">
    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" class="goo">
        <defs>
            <filter id="goo">
                <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"/>
                <feColorMatrix in="blur" mode="matrix"
                               values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"/>
                <feComposite in="SourceGraphic" in2="goo"/>
            </filter>
        </defs>
    </svg>

    <div class="button--bubble__container">
        <a @if(isset($link) && !empty($link)) href="{{ $link }}" @endif class="button button--bubble">
            {{ $text ?? " " }}
        </a>
        <div class="button--bubble__effect-container">
            <span class="circle top-left"></span>
            <span class="circle top-left"></span>
            <span class="circle top-left"></span>

            <span class="button effect-button"></span>

            <span class="circle bottom-right"></span>
            <span class="circle bottom-right"></span>
            <span class="circle bottom-right"></span>
        </div>
    </div>
</div>