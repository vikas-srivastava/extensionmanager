<h1>This is the Index action</h1>

	<% if ExtensionData %>
    <ul id="Extension-Data-List">
        <% control ExtensionData %>
        <li>
            
            <h2><a href="http://extension.silverstripe.org/module/show/$ID">$Name</a></h2>
            
        </li>
        <% end_control %>
    </ul>
   <% endif %>