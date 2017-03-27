<?php 
session_start();
ob_start();
//include("search_compete.php"); 
include ("includes/header.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
?>

<body onLoad="init();">

<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>


	<div class="body_section">
	
		<div class="body_container">
			<div class="body_top"> </div>
			<div class="main_body">
			
				<div class="contact_body_cont" style="min-height:600px;">
				
					<div class="user-profile-section">
						
						<div class="user-profile-top">
							<div class="profile-name">
								<h1>Michael's Profile</h1>
							</div>
							<div class="follow-section">
								<ul>
									<li>
										 <a href="javascript:void(0);">
											 <img src="images/star-on.png" /> <strong> Reviews</strong> <br />
											 <span>2,014</span>
										 </a>
									</li>
									
									<li>
										 <a href="javascript:void(0);">
											<strong>Following</strong> <br />
											 <span>2,014</span>
										 </a>
									</li>
									<li>
										 <a href="javascript:void(0);">
											<strong>Followers</strong> <br />
											 <span>2,014</span>
										 </a>
									</li>
									<li>
										 <a href="javascript:void(0);">
											<strong>Favorites</strong> <br />
											 <span>139</span>
										 </a>
									</li>
									<li>
										 <a href="javascript:void(0);" class="follow-btn"><img src="images/follower.png" align="absmiddle" /> Follow </a>
									</li>
								</ul>
							</div>
							<div class="clear"> </div>
						</div> <!-- End user-profile-top -->
						<div class="clear"> </div>
						
						<div class="user-cont">
							
							<div class="user-cont-left">
								<div class="pro-pic">
									<img src="images/profile_pic3.png" alt="" />
								</div>
								
								<label>
									<h5>Member Since</h5>
									<p>January 2014</p>
								</label>
								
								<label>
									<h5>Location</h5>
									<p>160 Lorem ipsum dolor, Lorem ipsum dolor sit amet</p>
								</label>
								
								<label>
									<input type="checkbox" class="regular-checkbox big-checkbox" name="review" id="review" />
									<label for="review"></label>
									
									 Review Votes
								</label>
								<div class="clear"> </div>
								
								<h4>
									<strong>3 likes</strong>,  
									<strong>2 dislikes</strong>
								</h4>
								
								<div class="review-up">
									<img src="images/reload.png" align="absmiddle" /> 1 Review update
								</div>
								<div class="clear"> </div>
								
								<div class="report-ab">
									<img src="images/report-flag.png" align="absmiddle" /> Report Abuse
								</div>
								<div class="clear"> </div>
								
								
								
							
							</div> <!-- End user-cont -->
							
							
							
							<div class="user-cont-right">
								<div class="right-top">
									<h4>
										Recent Reviews <span> 34 Reviews</span>
									</h4>
									<div class="clear"> </div>
									<ul class="sortby">
										<li>Sort by</li>
										<li><img src="images/right-small-arrow.png" align="absmiddle" /></li>
										<li><a href="javascript:void(0);">Date</a></li>
										
										<li>Filter by</li>
										<li><img src="images/right-small-arrow.png" align="absmiddle" /></li>
										<li><a href="javascript:void(0);"> Location</a></li>
										<li><a href="javascript:void(0);">Category</a></li>
									</ul>
									<div class="clear"> </div>
								</div>
								<div class="clear"> </div>
								
								<div class="right-top">
									
									<div class="restu-block">
										
										<div class="restu-block-left">
											<img src="images/thumbstrip10.jpg" align="" />
										</div>
										
										<div class="restu-block-right">
											<div class="restu-block-top">
												<div class="restu-name-sec">
													<h1>Lorem ipsum dolor sit amet</h1>
													<div class="clear"> </div>
													<a href="javascript:void(0);" class="small-cat">Categories : Lorem ipsum, dolor sit (dolor sit)</a>
													<div class="clear"> </div>
													<div class="rating_content">
														<ul>
															<li><img width="16" height="16" src="images/star-1.png"></li>
															<li><img width="16" height="16" src="images/star-1.png"></li>
															<li><img width="16" height="16" src="images/star-1.png"></li>
															<li><img width="16" height="16" src="images/star-1.png"></li>
															<li><img width="16" height="15" src="images/star-3.png"></li>
														</ul>
														
													</div> 
												</div>
												
												<div class="location-sec">
													<img src="images/address_pic.png" alt="" />
														160 Lorem ipsum dolor <br /> Lorem ipsum dolor sit amet
												</div>
											</div>
											<div class="clear"> </div>
											<div class="restu-block-botm">
												<p>
													Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
												</p>
												<div class="clear"> </div>
												
												<div class="like-sec">
													
													<div class="soc_icon">
														<a target="_blank" href="javascript:void(0);"> <img src="images/fb-like.png"></a>
													</div>
													<div class="soc_icon">
														<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=1194"> <img src="images/facebook_share.jpg"></a>
													</div>
													
													
												</div>
												
												<div class="clear"> </div>
											</div> 
											
											<div class="clear"> </div>
										</div>
										
										<div class="clear"> </div>
									</div> <!-- End restu-block -->
									
									<div class="restu-block">
										
										<div class="restu-block-left">
											<img src="images/thumbstrip10.jpg" align="" />
										</div>
										
										<div class="restu-block-right">
											<div class="restu-block-top">
												<div class="restu-name-sec">
													<h1>Lorem ipsum dolor sit amet</h1>
													<div class="clear"> </div>
													<a href="javascript:void(0);" class="small-cat">Categories : Lorem ipsum, dolor sit (dolor sit)</a>
													<div class="clear"> </div>
													<div class="rating_content">
														<ul>
															<li><img width="16" height="16" src="images/star-1.png"></li>
															<li><img width="16" height="16" src="images/star-1.png"></li>
															<li><img width="16" height="16" src="images/star-1.png"></li>
															<li><img width="16" height="16" src="images/star-1.png"></li>
															<li><img width="16" height="15" src="images/star-3.png"></li>
														</ul>
														
													</div> 
												</div>
												
												<div class="location-sec">
													<img src="images/address_pic.png" alt="" />
														160 Lorem ipsum dolor <br /> Lorem ipsum dolor sit amet
												</div>
											</div>
											<div class="clear"> </div>
											<div class="restu-block-botm">
												<p>
													Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
												</p>
												<div class="clear"> </div>
												
												<div class="like-sec">
													
													<div class="soc_icon">
														<a target="_blank" href="javascript:void(0);"> <img src="images/fb-like.png"></a>
													</div>
													<div class="soc_icon">
														<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=1194"> <img src="images/facebook_share.jpg"></a>
													</div>
													
													
												</div>
												
												<div class="clear"> </div>
											</div> 
											
											<div class="clear"> </div>
										</div>
										
										<div class="clear"> </div>
									</div> <!-- End restu-block -->
									
									
								</div>
								
								
							
							</div> <!-- End user-cont -->
							
						</div> <!-- End user-cont -->
						
						<div class="clear"> </div>
					</div> <!-- End user-profile-section -->
					
				
				
				
				
				
				
				
				</div>
			
			
			</div>
			<div class="body_footer_bg"> </div>
			<div class="clear"></div>
		</div>
	
	</div>

<div class="clear"></div>

<?php include("includes/footer.php");?>