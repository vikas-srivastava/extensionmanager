<div class="content-container">	
	<article>
		<h1>$Title</h1>
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

	<aside>
		<h3><a class="submitButton" href="{$Link}addnew">Submit new Theme Here</a></h3>	
	</aside>