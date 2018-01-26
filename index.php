<?php include 'inc/connection.php'?>
<?php

if (isset($_POST['mySubmit'])) {
    // someone clicked the submit button
    // define SQL string
    $insertSQL =
  "INSERT INTO
  `rating`
  (
  `ratingId`,
  `heroId`,
  `rating`,
  `ratingDate`,
  `ratingReview`
  )
  VALUES
  (
  null,
  '" . $_POST['heroId'] . "',
  '" . $_POST['rating'] . "',
  '" . date('Y-m-d G:i:s') . "',
  '" . $_POST['myMessage'] . "'
  )
  ";
    $result1 = $conn->query($insertSQL) or die($conn->error);
    header("Location: thanks.php");
}

 $sql1 = 'SELECT * FROM team';
  $result1 = $conn->query($sql1) or die($conn->error);

  $teams = array();

  if ($result1->num_rows > 0) {
      // output data of each row
      while ($row = $result1->fetch_assoc()) {
          $teams[]= $row;
      }
  }

  if (isset($_GET['teamId'])) {
      $teamId = $_GET['teamId'];

      $sql2 = 'SELECT * FROM hero WHERE teamId = ' . $teamId;
      $result2 = $conn->query($sql2) or die($conn->error);

      $heroes = array();

      if ($result2->num_rows > 0) {
          // output data of each row
          while ($row = $result2->fetch_assoc()) {
              $heroes[]= $row;
          }
      }

      if (isset($_GET['heroId'])) {
          $heroId = $_GET['heroId'];
          $sql3 = 'SELECT * FROM rating WHERE heroId = ' . "$heroId";
          $result3 = $conn->query($sql3) or die($conn->error);

          $heroDetail= array();
          if ($result3->num_rows > 0) {
              // output data of each row
              $row = $result3->fetch_assoc();
              $heroDetail = $row;
          }

          // get reviews (if not empty) from hero
          $selectReviewsQuery = "SELECT * FROM rating WHERE `ratingReview` != '' AND heroId = " . $heroId;

          $reviews    = array();
          $resource    = mysqli_query($conn, $selectReviewsQuery) or die(mysqli_error($conn));
          while ($row    = mysqli_fetch_assoc($resource)) {
              // add items to the array
              $reviews[] = $row;
          }
      }
      if (isset($_GET['heroId'])) {
          $heroId = $_GET['heroId'];
          $sql4 = 'SELECT * FROM hero WHERE heroId = ' . "$heroId";
          $result4 = $conn->query($sql4) or die($conn->error);

          $heroDetail= array();

          if ($result4->num_rows > 0) {
              // output data of each row
              $row = $result4->fetch_assoc();
              $heroDetail = $row;
          }
      }
  } else {
      $sql4 = 'SELECT * FROM hero';
      $result4 = $conn->query($sql4) or die($conn->error);

      $heroes = array();

      if ($result4->num_rows > 0) {
          // output data of each row
          while ($row = $result4->fetch_assoc()) {
              $heroes[]= $row;
          }
      }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/DClogo.png" type="image/png">
    <title>DC Heroes</title>
  </head>
  <body>
    <?php include 'inc/header.php'; ?>
    <div id="main-container">
    <div id="main-menu">
        <?php include 'inc/menu.php'; ?>
    </div>
    <div id="main-information">
      <?php
              foreach ($heroes as $hero) {
                  ?>

                <div id="superheroes-1">
                  <div id="heroImage">
                <?php
              echo "<img src='".$hero['heroImage']."'>"; ?>
              </div>
                <div id="heroName-one">    <?php
                echo $hero['heroName']; ?>
              </div><br /><br />
                <div id="heroLittleDescription1">
                  <?php echo $hero['heroPower']?>
              </div>
                <div id="Info-button">
                <a href="index.php?teamId=<?php echo $hero["teamId"]; ?>&heroId=<?php echo $hero["heroId"]; ?>"<h1>More Info</h1></a>
              </div>
              </div>
                <?php
              }
              ?>
    </div>
    <div id="main-rating">
        <?php
        // no heroId available / set
        if (isset($heroId)) {
            ?>
            <div id="heroImage-Rating">
          <img  src="images/superhero-even-background.jpg">
        </div>
        <div id="heroName-two">
          <?php
          echo $heroDetail['heroName']; ?>
        </div>
        <div id="superhero-Image">
          <?php echo "<img src='".$heroDetail['heroImage']."'>"; ?>
        </div>
          <div id="Description">
            Description:
          </div>
          <div id="heroDescription">
            <?php echo $heroDetail['heroDescription']; ?>
          </div>
          <div id="Powers">
            Powers:
          </div>
          <div id="heroPower">
            <?php echo $heroDetail['heroPower']; ?>
          </div>
          <form action="index.php" method="post">
            <?php
            echo $returnMessage; ?>
           <div id="rateHero">
             Rate:
           </div>
           <div class="rate">
   					<input required type="radio" id="rating10" name="rating" value="10" /><label class="lblRating" for="rating10" title="5 stars"></label>
   				    <input type="radio" id="rating9" name="rating" value="9" /><label class="lblRating half" for="rating9" title="4 1/2 stars"></label>
   				    <input type="radio" id="rating8" name="rating" value="8" /><label class="lblRating" for="rating8" title="4 stars"></label>
   				    <input type="radio" id="rating7" name="rating" value="7" /><label class="lblRating half" for="rating7" title="3 1/2 stars"></label>
   				    <input type="radio" id="rating6" name="rating" value="6" /><label class="lblRating" for="rating6" title="3 stars"></label>
   				    <input type="radio" id="rating5" name="rating" value="5" /><label class="lblRating half" for="rating5" title="2 1/2 stars"></label>
   				    <input type="radio" id="rating4" name="rating" value="4" /><label class="lblRating" for="rating4" title="2 stars"></label>
   				    <input type="radio" id="rating3" name="rating" value="3" /><label class="lblRating half" for="rating3" title="1 1/2 stars"></label>
   				    <input type="radio" id="rating2" name="rating" value="2" /><label class="lblRating" for="rating2" title="1 star"></label>
   				    <input type="radio" id="rating1" name="rating" value="1" /><label class="lblRating half" for="rating1" title="1/2 star"></label>
   				    <input type="radio" id="rating0" name="rating" value="0" /><label class="lblRating" for="rating0" title="No star"></label>
   				</div>
          <div id="rateReview">
            Review:
          </div>
            <input type="text" required name="myMessage" id="myMessage">

          </textarea>

            <br />
            <div id="divSubmit">
            <a><input type="submit" name="mySubmit" value="Rate <?php  echo $heroDetail['heroName']  ?>"/>
          </div></a>
            <input type="hidden" name="heroId" value="<?php echo $heroDetail['heroId'] ?>" />

          </form>
          <h3 class="reviewTable"><i class="far fa-comments"></i>&nbsp;Comments</h3>
      		<?php
              if (!empty($reviews)) {
                  // print table
                  echo "<table class=\"reviewTable\">";
                  foreach ($reviews as $heroReview) {
                      ?>
      				<tr>
      					<td><i class="far fa-calendar" style="font-size:24px; color: #0282f9;"></i></td>
      					<td><?php echo strftime("%d %B %Y"); ?></td>
      					<td><i class="far fa-clock" style="font-size:24px; color: #0282f9;"></i></td>
      					<td><?php echo strftime("%H:%M:%S"); ?></td>
      				</tr>
      				<tr><td colspan="4"><?php echo nl2br($heroReview['ratingReview']); ?></td></tr>
      				<tr><td colspan="4"><hr /></td></tr>
      				<?php
                  }
                  echo "</table>";
              } else {
                  ?>
      			<h5 class="reviewTable"><i class="fas fa-info-circle"></i>&nbsp;No comments yet..</h5>
      			<?php
              } ?>
            <?php
        } elseif (empty($heroDetail)) {
            ?>

          <h3 id="select-hero">Select a hero</h3>


          <?php
        }
         ?>
    </div>
  </div>

</body>
</html>
