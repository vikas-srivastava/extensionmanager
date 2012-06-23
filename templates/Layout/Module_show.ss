<div class="typography">

    <% include SideBar %>

    <div id="Content">

        <% control ExtensionData %>

            <h2>$Name</h2>
            <ul>
        	<% if $Description %>
                <li>
                    Description : $Description
                </li> 
            <% end_if %>
            
            <% if $Version %>
                <li>
                    Version : $Version
                </li>
            <% end_if %>

            <% if $Keywords %>
                <li>
                    Keywords : $Keywords
                </li>
            <% end_if %>
            
            <% if $Homepage %>
                <li>
                    <a href="$Homepage">Home Page</a>
                </li>
            <% end_if %>          

            <% if $ReleaseTime %>
                <li>
                    Release Time : $ReleaseTime 
                </li>
            <% end_if %>
            
            <% if $Licence %>
                <li>
                    Licence : $Licence
                </li>
            <% end_if %>
            
            <% if $SupportEmail %>
                <li>
                   Support Email : $SupportEmail
                </li>
            <% end_if %>

            <% if $SupportIssues %>
                <li>
                    <a href="$SupportIssues">Support Issues</a>
                </li>
            <% end_if %>

            <% if $SupportSource %>
                <li>
                    <a href="$SupportSource">Support Source</a>
                </li>
            <% end_if %>   
            
            <% if $SupportForum %>
                <li>
                    <a href="$SupportForum">Support Forum</a> 
                </li>
            <% end_if %>
            
            <% if $SupportWiki %>
                <li>
                    <a href="$SupportWiki">Support Wiki</a> 
                </li>
            <% end_if %>

            <% if $SupportIrc %>
                <li>
                   Support Irc : $SupportIrc
                </li>
            <% end_if %>

            <% if $TargetDir %>
                <li>
                   Target Directory : $TargetDir
                </li>
            <% end_if %>

            <% if $Require %>
                <li>
                   Requirements : $Require
                </li>
            <% end_if %>

            <% if $Repositories %>
                <li>
                   Repositories : $Repositories
                </li>
            <% end_if %>

            <% if $SubmittedByID %>
                <li>
                   Submitted By : $SubmittedByID
                </li>
            <% end_if %>
            
        <% end_control %>

        <% if $AuthorsDetail %>
            <ul>
            <h2>Authors Detail</h2>
                <li>
                    Author Name : $AuthorsDetail.AuthorName 
                </li>
                <li>
                    Author Email : $AuthorsDetail.AuthorEmail 
                </li>
                <li>
                    Author HomePage : $AuthorsDetail.AuthorHomePage 
                </li>
            </ul>
        <% end_if %>
        


    </div>

</div>