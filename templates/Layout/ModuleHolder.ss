<div class="content-container">	
	<article>
		<div class="content">$Content</div>
	</article>
	
	<div style= "float:Left;">
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
			<% loop moduleList %>
			<li><a class="Module link" href="module/show/$ID">$Name</a></li>
			<% end_loop %>
		</div>
	</div>

	<div style = "clear:both;"></div>
</div>