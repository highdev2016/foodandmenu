 <?php
    $currentFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $currentFile);
    $page= $parts[count($parts) - 1]; 
  ?> 
<div class="tab_section">
<ul>
                            <li <?php if($page == 'restaurant.php'){?> class="menu active" <?php } else { ?>class="menu" <?php } ?>><a href="restaurant.php?id=<?php echo $_REQUEST['id'];?>&deal_id=<?php echo $_REQUEST['deal_id']; ?>#tab">Menu</a></li>
                            <li <?php if($page == 'reservation.php'){?> class="review active" <?php } else { ?>class="review" <?php } ?>><a href="reservation.php?id=<?php echo $_REQUEST['id'];?>&deal_id=<?php echo $_REQUEST['deal_id']; ?>#tab">Reservation</a></li>
                            <li <?php if($page == 'profile.php'){?> class="profile active" <?php } else { ?>class="profile" <?php } ?>><a href="profile.php?id=<?php echo $_REQUEST['id'];?>&deal_id=<?php echo $_REQUEST['deal_id']; ?>#tab">Profile</a></li>
                            <li <?php if($page == 'review.php' || $page == 'write_review.php'){?> class="review active" <?php } else { ?>class="review" <?php } ?>><a href="review.php?id=<?php echo $_REQUEST['id'];?>&deal_id=<?php echo $_REQUEST['deal_id']; ?>#tab">Review</a></li>
                            
                            
                        </ul>
                        <?php if($page == 'review.php'){ ?>
                        <select class="review_select_box" name="sort_review" onchange="display_reviews(<?php echo $_GET['id'] ?>,this.value);">
                            <option class="dish_select_text">- Select Category -</option>
                            <option class="dish_select_text" value="most-recent" <?php echo ($_REQUEST['order']=='most-recent')?'selected="selected"':'' ?> >Most Recent</option>
                            <option class="dish_select_text" value="most-rated" <?php echo ($_REQUEST['order']=='most-rated')?'selected="selected"':'' ?>>Rating</option>
                        </select>
                        </div>
                        <?php } ?>