# PHP-Rest-Snippet

# Simple snippet in PHP for a basic REST Api containing all CRUD operations, pagination and search


API URL Examples: <br />

<ul>
 <li>No params --> GET http://localhost/api/user/read.php</li>
 <li>
   <ul>
    <li>Body params</li>
    <li>POST http://localhost/api/user/create.php</li>
    <li>BODY: {"email": "mymail@mail.com", "password": "mypassword"}</li>
  </ul>
  </li>
 <li>Query params --> GET http://localhost/api/user/read_paging.php?start=2&limit=1</li>
</ul>
