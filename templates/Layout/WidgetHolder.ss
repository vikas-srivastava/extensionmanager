<div class="content-container">	
	<article>
		<div class="content">$Content</div>
	</article>
	
	<div style= "float:Left;">
		<% if widgetSearch %>
		<h1>Search Widget</h1>
		$widgetSearch
		<% end_if %>
	</div>

	<div style = "float:Right;">
		<div style= "float:Right;margin-top:50px;margin-bottom:30px;">
			<h3>
				<a class="submitButton" href="{$Link}addnew">Submit new Widget Here</a>
			</h3>
		</div>

		<div>
			<h3>Available Widgets</h3>
			<% loop widgetList %>
			<li><a class="widget link" href="widget/show/$ID">$Name</a></li>
			<% end_loop %>
		</div>
	</div>
	<div style = "clear:both;"></div>

	<div style = "margin-top:30px;">
		<% if FormSubmitted %>
		<% include ExtensionSearch %>
		<% end_if %>
	</div>

</div>