<div class="typography">

    <% include SideBar %>

    <div id="Content">

    <% if ExtensionData %>
    <ul >
        <% control ExtensionData %>
        <h1>$Name</h1>    

         <% if $Url %>
            <li>
                <a href="$Url">Repository </a>
            </li>
        <% end_if %>

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

        <h2>Support </h2>
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

        <% end_control %>
    </ul>
    <% end_if %>
    <ul>
        <% if $Keywords %>
            <li>
                Keywords : $Keywords
            </li>
        <% end_if %>
        
        <% if $SubmittedBy %>
            <li>
                Submitted By : $SubmittedBy
            </li>
        <% end_if %>               

        <!--
        <% if $Licence %>
            <li>
                Licence : $Licence
            </li>
        <% end_if %> 
        -->
        <% if $AuthorsDetail %>
            <h1>AuthorsDetail</h1>
            <% control AuthorsDetail %>
            <ul>
                <% if $AuthorName %>
                <li>
                    Author Name : $AuthorName
                </li>
                <% end_if %>  

                <% if $AuthorEmail %>
                <li>
                    Author Email : $AuthorEmail 
                </li>
                <% end_if %>  

                <% if $AuthorHomePage %>
                <li>
                    Author HomePage : 
                    <a href="$AuthorHomePage "> $AuthorHomePage </a>
                <li>
                <% end_if %>

                <% if $AuthorRole %>
                <li>
                    Author Email : $AuthorRole 
                </li>
                <% end_if %>  
            </ul>
            <% end_control %>
            
        <% end_if %>  

    </ul>
        
    </div>

</div>