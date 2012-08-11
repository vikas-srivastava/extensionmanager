<div class="content-container">	
	<article>
		<div class="content">$Content</div>
	</article>
	
	<h3>Available Themes</h3>
	<ol>
	<% loop themeList %> 
			
			<li><a class="Module link" href="theme/show/$ID">$Name</a></li>
			
	<% end_loop %>
	</ol>
			
	$PageComments

</div>
<% include SideBar %>

<h3><a class="submitButton" href="{$Link}addnew">Submit new Theme Here</a></h3>	