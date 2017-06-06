<div class = "left_menu_container border_thm">
	<div class = "left_content" style = "margin-top: 0px;">
		<?php if($user_access <= 1): ?>
			<div class = "text_title2 menu_title" style ="cursor: pointer;" label = "Collapse Admin Options"> Admin Options</div>
			<a href = "<?php echo base_url();?>index.php/manage_announcements"><div class = "menu_item <?php if($current_location == 'manage_announcements'):?>selected <?php endif; ?>">
			Manage Announcements
			</div></a>
			<a href = "<?php echo base_url();?>index.php/setup_year_level"><div class = "menu_item <?php if($current_location == 'manage_year_level'):?>selected <?php endif; ?>">
			Set Up Year Level
			</div></a>
			<a href = "<?php echo base_url();?>index.php/setup_section"><div class = "menu_item <?php if($current_location == 'setup_section'):?>selected <?php endif; ?>">
			Set Up Section
			</div></a>
			<a href = "<?php echo base_url();?>index.php/setup_subject" ><div class = "menu_item <?php if($current_location == 'setup_subject'):?>selected <?php endif; ?>">
			Set Up Subject
			</div></a>
			<a href = "<?php echo base_url();?>index.php/setup_enrollment" ><div class = "menu_item <?php if($current_location == 'setup_enrollment'):?>selected <?php endif; ?>">
			Manage Enrollment
			</div></a>
			<a href = "<?php echo base_url();?>index.php/setup_users"><div class = "menu_item <?php if($current_location == 'setup_users'):?>selected <?php endif; ?>">
			Users
			</div></a>
		<?php endif; ?>
		
		<?php if($user_access <= 2): ?>
			<div class = "text_title2 menu_title" style ="cursor: pointer;" label = "Collapse Admin Options"> Enrollment Options</div>
			<a href = "<?php echo base_url();?>index.php/student_data"><div class = "menu_item">
			Student Data
			</div></a>
			<a href = "<?php echo base_url();?>index.php/enroll_student"><div class = "menu_item">
			Enroll Student
			</div></a>
			<a href = "<?php echo base_url();?>index.php/enrollment_reporting"><div class = "menu_item">
			Reporting
			</div></a>
		<?php endif; ?>
		
		<?php if($user_access <= 2): ?>
		<div class = "text_title2 menu_title" style ="cursor: pointer;" label = "Collapse Admin Options"> Teacher Options</div>
		<a href = "<?php echo base_url();?>index.php/announcement"><div class = "menu_item <?php if($current_location == 'announcements'):?>selected <?php endif; ?>">
		Announcements
		</div></a>
		<a href = "<?php echo base_url();?>index.php/grades"><div class = "menu_item">
		Grades
		</div></a>
		<a href = "<?php echo base_url();?>index.php/grade_reporting"><div class = "menu_item">
		Grade Reporting
		</div></a>
		<a href = "<?php echo base_url();?>index.php/contributions"><div class = "menu_item">
		Contributions
		</div></a>
		<?php endif; ?>
	</div>
</div>