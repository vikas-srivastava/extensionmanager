<div class="content-container">	
	<article>
		<div class="content">$Content</div>
	</article>
	
	<div style= "float:Left;">
		<% if themeSearch %>
		<h1>Search Theme</h1>
		$themeSearch
		<% end_if %>
	</div>

	<div style = "float:Right;">
		<div style= "float:Right;margin-top:50px;margin-bottom:30px;">
			<h3>
				<a class="submitButton" href="{$Link}addnew">Submit new Theme Here</a>
			</h3>
		</div>

		<div>
			<h3>Available Themes</h3>
			<% loop themeList %>
			<li><a class="Module link" href="theme/show/$ID">$Name</a></li>
			<% end_loop %>
		</div>
	</div>

	<div style = "clear:both;"></div>
</div>