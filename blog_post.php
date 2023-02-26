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
      <?php
      // Get the post title from the URL parameter
      $post_title = $_GET['post'];

      // Find the post in the CSV file
      $csv = array_map('str_getcsv', file('blog_posts.csv'));
      $headers = array_shift($csv); // Remove headers from array
      foreach ($csv as $row) {
        if (strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', $row[0])) === $post_title) {
          $post_title = $row[0];
          $author_name = $row[1];
          $post_date = $row[2];
          $post_content = $row[3];
          break;
        }
      }
      ?>
      <h2><?php echo $post_title; ?></h2>
      <p><?php echo $author_name; ?> | <?php echo $post_date; ?></p>
      <p><?php echo $post_content; ?></p>
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
