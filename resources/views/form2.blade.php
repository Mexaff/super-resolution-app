<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Super-Resolution</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        input[type="file"], select {
            display: block;
            margin: 20px auto;
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            box-sizing: border-box;
        }
        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .form-group {
            margin: 15px 0;
        }
        #preview {
            margin: 20px auto;
            max-width: 100%;
            max-height: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: none; /* Скрыто до загрузки */
        }
        .loader {
            display: none;
            margin-top: 20px;
        }
        .loader span {
            font-size: 16px;
            color: #555;
        }
        .loader .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007BFF;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Upload Image for Super-Resolution</h1>
    <form id="uploadForm" action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="file" name="image" id="imageInput" accept="image/*" required>
        </div>
        <div class="form-group">
            <select name="method" required>
                <option value="" disabled selected>Select Processing Method</option>
                <option value="ESRGAN">ESRGAN</option>
                <option value="CNN">CNN</option>
            </select>
        </div>
        <div class="form-group">
            <img id="preview" alt="Image Preview">
        </div>
        <div class="form-group">
            <button type="submit" id="submitButton">Enhance Image</button>
        </div>
        <div class="loader" id="loader">
            <div class="spinner"></div>
            <span>Processing...</span>
        </div>
    </form>
</div>
<script>
    const form = document.getElementById('uploadForm');
    const submitButton = document.getElementById('submitButton');
    const loader = document.getElementById('loader');

    form.addEventListener('submit', function () {
        // Скрыть кнопку отправки и показать лоадер
        submitButton.style.display = 'none';
        loader.style.display = 'block';
    });

    const imageInput = document.getElementById('imageInput');
    const preview = document.getElementById('preview');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (event) {
                preview.src = event.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            preview.src = '';
        }
    });
</script>
</body>
</html>
