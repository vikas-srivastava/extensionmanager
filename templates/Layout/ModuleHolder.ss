<div class="content-container">	
	<article>
		<div class="content">$Content</div>
	</article>
	
	<div style= "float:Left; width:70%;">
		<% if moduleSearch %>
		<h1>Search Module</h1>
		$moduleSearch
		<% end_if %>
	</div>

	<div style = "float:Right;">
		<div style= "float:Right;margin-top:50px;margin-bottom:30px;">
			<h3>
				<a class="submitButton" href="{$Link}addnew">Submit new Module Here</a>
			</h3>
		</div>

		<div>
			<h3>Available Modules</h3>
			<%if ModuleList %>
			<% loop ModuleList %>
			<li><a href="module/show/$ID">$Name</a></li>
			<% end_loop %>
			<% end_if %>
		</div>
	</div>

	<div style = "clear:both;"></div>

	<div style = "margin-top:30px;">
		<%if NewExtension %>
		<h1>New Modules</h1>
		(Images should display in slideshow/showcase)
		<% loop NewExtension %>
		<h3><a href="module/show/$ID">$Name</a></h3>
		<a href="module/show/$ID">
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