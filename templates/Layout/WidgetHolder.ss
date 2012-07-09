<div class="content-container">	
	<article>
		<h1>$Title</h1>
		<div class="content">$Content</div>
	</article>
	
	<h3>Available Themes</h3>
	<ol>
	<% loop widgetList %> 
			
			<li><a class="widget link" href="widget/show/$ID">$Name</a></li>
			
	<% end_loop %>
	</ol>
	
	<h3>Submit new Widget</h3>
	<p><h3><a class="submitButton" href="{$Link}addnew">Here</a></h3></p>
		
	$PageComments
</div>
<% include SideBar %>