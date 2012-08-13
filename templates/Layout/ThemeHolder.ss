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
			<%if ThemeList %>
			<% loop ThemeList %>
			<li><a href="theme/show/$ID">$Name</a></li>
			<% end_loop %>
			<% end_if %>
		</div>
	</div>
	<div style = "clear:both;"></div>

	<div style = "margin-top:30px;">
		<%if NewExtension %>
		<h1>New Themes</h1>
		(Images should display in slideshow/showcase)
		<% loop NewExtension %>
		<h3><a href="theme/show/$ID">$Name</a></h3>
		<a href="theme/show/$ID">
			<img src="$Thumbnail.URL" border="2" style="border:2px solid black;max-width:40%;" alt="$Thumbnail.Name" />
		</a>
		<% end_loop %>
		<% end_if %>
	</div>

	<div style = "margin-top:30px;">
		<% if FormSubmitted %>
		<% include ExtensionSearch %>
		<% end_if %>
	</div>

</div>