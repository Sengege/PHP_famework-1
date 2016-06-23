<?php
	require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
?>

<nav id="zlight-nav">
	<ul id="zlight-main-nav">
		<li class="zlight-dropdown">
			<a href="home.php">
				<img src="../images/parent.png" width="50%" />
			</a>
			<ul class="zlight-submenu">
				<li class="zlight-dropdown">
					<a href="cate_items.php?category_type_id=<?php echo urlencode(ITEM)?>">ITEMS</a>
					<ul class="zlight-submenu">
						<li>
							<a href="cate_items_cate.php?category_type_id=<?php echo urlencode(ITEM)?>&sub_category_type_id=<?php echo urlencode(CLOTHES)?>">Clothes</a>
						</li>
						<li>
							<a href="cate_items_cate.php?category_type_id=<?php echo urlencode(ITEM)?>&sub_category_type_id=<?php echo urlencode(BOOKS)?>">Books</a>
						</li>
						<li>
							<a href="cate_items_cate.php?category_type_id=<?php echo urlencode(ITEM)?>&sub_category_type_id=<?php echo urlencode(FURNITURE)?>">Furniture</a>
						</li>
						<li>
							<a href="cate_items_cate.php?category_type_id=<?php echo urlencode(ITEM)?>&sub_category_type_id=<?php echo urlencode(ELECTRONICS)?>">Electronics</a>
						</li>
						<li>
							<a href="cate_items_cate.php?category_type_id=<?php echo urlencode(ITEM)?>&sub_category_type_id=<?php echo urlencode(GAMES)?>">Games</a>
						</li>
						<li>
							<a href="cate_items_cate.php?category_type_id=<?php echo urlencode(ITEM)?>&sub_category_type_id=<?php echo urlencode(OTHER)?>">Other</a>
						</li>
					</ul>
				</li>
				<li class="zlight-dropdown">
					<a href="cate_skills.php?category_type_id=<?php echo urlencode(SKILL)?>">SKILLS</a>
					<ul class="zlight-submenu">
						<li>
							<a href="cate_skills_cate.php?category_type_id=<?php echo urlencode(SKILL)?>&sub_category_type_id=<?php echo urlencode(ACADEMIC)?>">Academic</a>
						</li>
						<li>
							<a href="cate_skills_cate.php?category_type_id=<?php echo urlencode(SKILL)?>&sub_category_type_id=<?php echo urlencode(COMPUTER)?>">Computer</a>
						</li>
						<li>
							<a href="cate_skills_cate.php?category_type_id=<?php echo urlencode(SKILL)?>&sub_category_type_id=<?php echo urlencode(ARTISTIC)?>">Artistic</a>
						</li>
						<li>
							<a href="cate_skills_cate.php?category_type_id=<?php echo urlencode(SKILL)?>&sub_category_type_id=<?php echo urlencode(COOKING)?>">Cooking</a>
						</li>
						<li>
							<a href="cate_skills_cate.php?category_type_id=<?php echo urlencode(SKILL)?>&sub_category_type_id=<?php echo urlencode(LANGUAGES)?>">Languages</a>
						</li>
						<li>
							<a href="cate_skills_cate.php?category_type_id=<?php echo urlencode(SKILL)?>&sub_category_type_id=<?php echo urlencode(OTHER)?>">Other</a>
						</li>
					</ul>
				</li>
				<li class="zlight-dropdown">
					<a href="cate_experiences.php?category_type_id=<?php echo urlencode(EXPERIENCE)?>">EXPERIENCES</a>
					<ul class="zlight-submenu">
						<li>
							<a href="cate_exper_cate.php?category_type_id=<?php echo urlencode(EXPERIENCE)?>&sub_category_type_id=<?php echo urlencode(TRAVEL)?>">Travel</a>
						</li>
						<li>
							<a href="cate_exper_cate.php?category_type_id=<?php echo urlencode(EXPERIENCE)?>&sub_category_type_id=<?php echo urlencode(FOOD)?>">Food</a>
						</li>
						<li>
							<a href="cate_exper_cate.php?category_type_id=<?php echo urlencode(EXPERIENCE)?>&sub_category_type_id=<?php echo urlencode(HISTORY)?>">History</a>
						</li>
						<li>
							<a href="cate_exper_cate.php?category_type_id=<?php echo urlencode(EXPERIENCE)?>&sub_category_type_id=<?php echo urlencode(FITNESS)?>">Fitness</a>
						</li>
						<li>
							<a href="cate_exper_cate.php?category_type_id=<?php echo urlencode(EXPERIENCE)?>&sub_category_type_id=<?php echo urlencode(CULTURE)?>">Culture</a>
						</li>
						<li>
							<a href="cate_exper_cate.php?category_type_id=<?php echo urlencode(EXPERIENCE)?>&sub_category_type_id=<?php echo urlencode(OTHER)?>">Other</a>
						</li>
					</ul>
				</li>
			</ul>
		</li>
	</ul>
	<div id="zlight-mobile-nav">
		<span>Menu</span>

	<select></select>
</div>
</nav>