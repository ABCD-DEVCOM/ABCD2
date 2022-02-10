<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex, nofollow">
  <title>Classic editor with default styles</title>
  <script src="/central/ckeditor/ckeditor.js"></script>
</head>

<body>
  <textarea cols="80" id="editor1" name="editor1" rows="10" data-sample-short>&lt;p&gt;This is some &lt;strong&gt;sample text&lt;/strong&gt;. You are using &lt;a href=&quot;https://ckeditor.com/&quot;&gt;CKEditor&lt;/a&gt;.&lt;/p&gt;</textarea>
  <script>
    CKEDITOR.replace('editor1', {
      height: 260,
      width: 700,
    });
  </script>
</body>

</html>