<div class="content-container">	
	<article>
		<div class="content">$Content</div>
	</article>
	
	<h3>Available Modules</h3>
	<ol>
	<% loop moduleList %> 
			
			<li><a class="Module link" href="module/show/$ID">$Name</a></li>
			
	<% end_loop %>
	</ol>
	$PageComments
</div>
<% include SideBar %>
	
<h3><a class="submitButton" href="{$Link}addnew">Submit new Module Here</a></h3>	