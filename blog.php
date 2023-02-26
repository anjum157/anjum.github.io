<!DOCTYPE html>
<html>
<head>
  <title>Hannan Anjum Webspace</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="header"></div>
  
  <main>
    <section>
      <h2>Latest Posts</h2>
      <ul>
        <?php
        $csv = array_map('str_getcsv', file('blog_posts.csv'));
        $headers = array_shift($csv); // Remove headers from array
        foreach ($csv as $row) {
          $post_title = $row[0];
          $author_name = $row[1];
          $post_date = $row[2];
          $post_content = $row[3];
          $post_url = preg_replace('/[^a-zA-Z0-9\-]/', '', strtolower($post_title));
          echo "<li>
                  <h3><a href='blog_post.php?post=$post_url'>$post_title</a></h3>
                  <p>$author_name | $post_date</p>
                  <p>" . substr($post_content, 0, 200) . "...</p>
                </li>";
        }
        ?>
      </ul>
    </section>
  </main>

  <div id="footer"></div>

  <div id="contactModal" style="display: none;">
    <div>
      <button id="closeBtn">&times;</button>
      <form action="contact.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <label for="message">Message:</label>
        <textarea id="message" name="message"></textarea>

        <input type="submit" value="Send">
      </form>
    </div>
  </div>

  <script>
    const contactBtn = document.getElementById("contactBtn");
    const contactModal = document.getElementById("contactModal");
    const closeBtn = document.getElementById("closeBtn");

    contactBtn.addEventListener("click", function() {
      contactModal.style.display = "block";
    });

    closeBtn.addEventListener("click", function() {
      contactModal.style.display = "none";
    });

    contactModal.addEventListener("submit", function() {
      // Handle form submission here
      contactModal.style.display = "none";
    });
  </script>

  <script>
    // Load the header content
    var xhttpHeader = new XMLHttpRequest();
    xhttpHeader.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("header").innerHTML = this.responseText;
      }
    };
    xhttpHeader.open("GET", "header.html", true);
    xhttpHeader.send();

    // Load the footer content
    var xhttpFooter = new XMLHttpRequest();
    xhttpFooter.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("footer").innerHTML = this.responseText;
      }
    };
    xhttpFooter.open("GET", "footer.html", true);
    xhttpFooter.send();
  </script>

</body>
</html>