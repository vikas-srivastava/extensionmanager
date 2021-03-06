<!-- ToDo -
Right Now all module/widget/themes are look similar. But they will change later
according to diffrent design and data
-->

<div class="content-container">

    <div class="content">$Content</div>

    <ul >
        <% with SelectedModule %>

        <% if $Accepted != 1 %>
        <h1>This Widget is yet not Approved by Module Moderators</h1>
        <% end_if %>

        <h1>$Name</h1>

        <h3> Vendor Name : $VendorName </h3>

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

        <% if $CompatibleSilverStripeVersion %>
        <li>
            Compatible SilverStripe Version : $CompatibleSilverStripeVersion
        </li>
        <% end_if %>

        <% if $Homepage %>
        <li>
            <a href="$Homepage">Home Page</a>
        </li>
        <% end_if %>


        <% if $Category %>
        <li>
            Category : $Category.CategoryNames
        </li>
        <% end_if %>

        <h3><a href="$DownloadLink.DistUrl"> Download Latest Version</a></h3>

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
    </ul>
    <ul>
        <% if $Keywords %>
        <h3>Keywords</h3>
        <% loop Keywords %>
        $KeywordName
        <% end_loop %>
        <% end_if %>

        <% if $SubmittedBy %>
        <h3>Submitted By</h3>
        <li>
            Submitted By : $SubmittedBy.Name
        </li>
        <% end_if %>

        <% if ExtensionAuthors %>
        <h2>Authors Detail</h2>
        <% loop $ExtensionAuthors %>
        <p>
            <ul>
                <% if $Name %>
                <li>
                    Author Name : $Name
                </li>
                <% end_if %>

                <% if $Email %>
                <li>
                    Author Email : $Email
                </li>
                <% end_if %>

                <% if $HomePage %>
                <li>
                    Author HomePage :
                    <a href="$AuthorHomePage "> $HomePage  </a>
                </li>
                <% end_if %>

                <% if $Role %>
                <li>
                    Author Email : $Role
                </li>
                <% end_if %>
            </ul>
        </p>
        <% end_loop %>
        <% end_if %>

        <% if ExtensionVersions %>
        <h2>Subversion Detail</h2>
        <% loop ExtensionVersions %>
        <p>
            <h3>$PrettyVersion </h3>
            <a href="$DistUrl"> Download $DistType</a><br>
            <a href="$SourceUrl"> Source Url</a><br><br>
        </p>
        <% end_loop %>
        <% end_if %>

        <!--  Resize according to theme -->
        <% if $Thumbnail %>
            <img src="$Thumbnail.Url" border="2" style="border:2px solid black;max-width:40%;"alt="$Thumbnail.Name"/>
         <% end_if %>
        <% end_with %>
        <div style = "margin-top:30px;">
        <% if $Disqus %>
            $Disqus
        <% end_if %>
        </div>
    </ul>
</div>