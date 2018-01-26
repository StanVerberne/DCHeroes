<nav id="main-nav">
  <div id="Categories">
    <h1 id="main-teams">Teams<h1>
  <?php
  foreach ($teams as $team) {
      ?>
    <ul><a href="index.php?teamId=<?php echo $team["teamId"]; ?>"><div id="teamImage"><?php  echo "<img src='".$team["teamImage"]."'>" ?></div><h2 id="Category-teams"><?php echo $team["teamName"]; ?></h2></a></ul>
    <?php
  }
   ?>
</div>
  </nav>
