@props(['imageUrl', 'name'])

<div class="image-upload-component">
    <div class="image-preview mx-0" id="imagePreview"
        style="background-image: url('{{ $imageUrl ? asset('public/storage/' . $imageUrl) : asset('public/logo/default.png') }}');">
        <span id="changeText">Upload Image</span>
    </div>
    <input type="file" id="imageInput" name="{{ $name }}" accept="image/*" style="display: none;">
</div>

<style>
    .image-upload-component {
        cursor: pointer;
        text-align: center;
    }

    .image-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        background-color: #f3f3f3;
        border: 2px dashed #ccc;
        position: relative;
        margin: 0 auto;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        font-size: 14px;
        font-weight: bold;
        overflow: hidden;
    }

    .image-preview:hover {
        border-color: #007bff;
    }

    #changeText {
        visibility: hidden;
        position: absolute;
        z-index: 2;
    }

    .image-preview:hover #changeText {
        visibility: visible;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        z-index: 1;
    }
</style>

<script>
    $(document).ready(function() {
        const imagePreview = $('#imagePreview');
        const imageInput = $('#imageInput');

        // Trigger file input on preview click
        imagePreview.on('click', function() {
            imageInput.click();
        });

        // Handle file input change and AJAX upload
        imageInput.on('change', function() {
            const file = this.files[0];
            if (file) {
                // Preview the selected image
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.css('background-image', `url(${e.target.result})`);
                    $('#changeText').text('Change Image');
                    $('.getInitials').text('');
                };
                reader.readAsDataURL(file);

                // Create FormData object for AJAX upload
                const formData = new FormData();
                formData.append('image', file);

            }
        });
    });
</script>
