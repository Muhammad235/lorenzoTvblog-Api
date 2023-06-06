const settings = {
  "async": true,
  "crossDomain": true,
  "url": "http://localhost/lorenzoTvblog-Api/lorenzoblogapi/upload/upload.php?title=first%20post&category=tech&blog_content=content&thumbnail=test.png&author=me",
  "method": "POST",
  "headers": {},
  "processData": false,
  "data": "{\"title\":\"first post\",\"category\":4,\"blog_content\":\"blog post\",\"thumbnail\":\"thumbnail\",\"author\":\"author\"}"
};

$.ajax(settings).done(function (response) {
  console.log(response);
});