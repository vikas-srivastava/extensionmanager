<div class="content-container">	
	<article>
		<h1>$Title</h1>
		<div class="content">$Content</div>
	</article>
	<% if CurrentMember %>
		<% if Success %>
			$SubmitText
		<% else %>	
			$ModuleUrlForm
		<% end_if %>	
	<% end_if %>
	$PageComments
</div>
<% include SideBar %>