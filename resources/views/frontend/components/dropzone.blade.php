<div class="image-uploader">

    <div class=" preview {{ isset($dz_gallery) && $dz_gallery == true ? 'multiple' : 'single'  }}">
        @if(isset($dz_gallery) && $dz_gallery == true)

            <ul class="m">
                @if(is_array($dz_value) && !empty($dz_value))
                    @foreach($dz_value as $dv)
                        <li>
                            <img src="{{ $dv }}">
                            <span class="fas fa-trash remove-image"></span>
                            <input type="hidden" name="{{ $dz_name ?? 'image_gallery' }}[]"
                                   class="hiddenImage"
                                   value="{{ filter_path_url($dv) }}">
                        </li>
                    @endforeach
                @endif

            </ul>
        @else
            <div class="s">
                <img src="{{ $dz_value ?? '/img/blank.gif' }}">
                <span class="fas fa-trash remove-image"></span>
                <input type="hidden" id="{{ $dz_name ?? 'image' }}" name="{{ $dz_name ?? 'image' }}"
                       class="hiddenImage"
                       value="{{ isset($dz_value) ? filter_path_url($dz_value) : '' }}">
            </div>
        @endif

    </div>
    <div class=" dZUpload dropzone"
         data-type="{{ $dz_type ?? '' }}"
         data-w="{{ $dz_width ?? 1024 }}"
         data-h="{{ $dz_height ?? 1024 }}"
         data-r="{{ $dz_ratio ?? '' }}"
         data-g="{{ $dz_gallery ?? 'false' }}"
         data-n="{{ $dz_name ?? 'image_gallery' }}"
    ><div class="dz-message" data-dz-message><span><i class="fa fa-upload"></i> Resim yükle</span></div>
    </div>
</div>
