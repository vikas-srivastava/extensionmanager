<div class="content-container">	
	<article>
		<div class="content">$Content</div>
	</article>
	
	<div style= "float:Left; width:70%;">
		<% if widgetSearch %>
		<h1>Search Widget</h1>
		$widgetSearch
		<% end_if %>
	</div>

	<div style = "float:Right;">
		<div style= "float:Right;margin-top:50px;margin-bottom:30px;">
			<% with WidgetSubmissionForm %> $Content <br> $Form <% end_with %>
		</div>

		<div>
			<h3>Available Widgets</h3>
			<%if WidgetList %>
			<% loop widgetList %>
			<li><a href="widget/show/$ID">$Name</a></li>
			<% end_loop %>
			<% end_if %>
		</div>
	</div>
	<div style = "clear:both;"></div>

	<div style = "margin-top:30px;">
		<%if NewExtension %>
		<h1>New Widgets</h1>
		(Images should display in slideshow/showcase)
		<% loop NewExtension %>
		<h3><a href="widget/show/$ID">$Name</a></h3>
		<a href="widget/show/$ID">
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