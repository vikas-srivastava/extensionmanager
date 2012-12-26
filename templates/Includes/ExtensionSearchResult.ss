<div id="Content" class="searchResults typography">
    
    <h1>$SearchTitle</h1>
    <% if Query %>
    <p class="searchQuery"><strong>You searched for &quot;{$Query}&quot;</strong></p>
    <% end_if %>

    <% if ExtensionSearchResults %>
    <ul id="SearchResults">
        <% control ExtensionSearchResults %>
        <li>
            <a class="searchResultHeader" href="$DetailPageLink">
                $Name
            </a>
            <p>$Description</p>
            <p>$Content.LimitWordCountXML</p>
            <a class="readMoreLink" href="$DetailPageLink" title="Read more about &quot;{$Name}&quot;">Read more about &quot;{$Name}&quot;...</a>
        </li>
        <% end_control %>
    </ul>
    <% else %>
    <p>Sorry, your search query did not return any results.</p>
    <% end_if %>

    <% if ExtensionSearchResults.MoreThanOnePage %>
    <div id="PageNumbers">
        <div class="pagination">
            <% if ExtensionSearchResults.NotFirstPage %>
            <a class="prev" href="$ExtensionSearchResults.PrevLink" title="View the previous page">&larr;</a>
            <% end_if %>
            <span>
                <% control ExtensionSearchResults.Pages %>
                <% if CurrentBool %>
                $PageNum
                <% else %>
                <a href="$Link" title="View page number $PageNum" class="go-to-page">$PageNum</a>
                <% end_if %>
                <% end_control %>
            </span>
            <% if ExtensionSearchResults.NotLastPage %>
            <a class="next" href="$ExtensionSearchResults.NextLink" title="View the next page">&rarr;</a>
            <% end_if %>
        </div>    
        <p>Page $ExtensionSearchResults.CurrentPage of $ExtensionSearchResults.TotalPages</p>
    </div>
    <% end_if %>
</div>