<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Super-Resolution</title>
</head>
<body>
<h1>Upload Image for Super-Resolution</h1>
<form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" required>
    <button type="submit">Enhance Image</button>
</form>
</body>
</html>
