const options = {
  method: 'POST',
  body: '{"title":"first post","category":4,"blog_content":"blog post","thumbnail":"thumbnail","author":"author"}'
};

fetch('http://localhost/lorenzoTvblog-Api/lorenzoblogapi/upload/upload.php?title=first%20post&category=tech&blog_content=content&thumbnail=test.png&author=me', options)
  .then(response => response.json())
  .then(response => console.log(response))
  .catch(err => console.error(err));