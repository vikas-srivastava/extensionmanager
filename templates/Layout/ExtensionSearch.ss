<div id="Content" class="searchResults typography">
    <h1>Search Result</h1>
    <% if Query %>
    <p class="searchQuery"><strong>You searched for &quot;{$Query}&quot;</strong></p>
    <% end_if %>
    
    <% if Results %>
    <ul id="SearchResults">
        <% control Results %>
        <% if Accepted %>
        <li>
            <a class="searchResultHeader" href="$DetailPageLink">
                $Name
            </a>
            <p>$Description</p>
            <p>$Content.LimitWordCountXML</p>
            <a class="readMoreLink" href="$DetailPageLink" title="Read more about &quot;{$Name}&quot;">Read more about &quot;{$Name}&quot;...</a>
        </li>
        <% end_if %>
        <% end_control %>
    </ul>
    <% else %>
    <p>Sorry, your search query did not return any results.</p>
    <% end_if %>
    
    <% if Results.MoreThanOnePage %>
    <div id="PageNumbers">
        <div class="pagination">
            <% if Results.NotFirstPage %>
            <a class="prev" href="$Results.PrevLink" title="View the previous page">&larr;</a>
            <% end_if %>
            <span>
                <% control Results.Pages %>
                <% if CurrentBool %>
                $PageNum
                <% else %>
                <a href="$Link" title="View page number $PageNum" class="go-to-page">$PageNum</a>
                <% end_if %>
                <% end_control %>
            </span>
            <% if Results.NotLastPage %>
            <a class="next" href="$Results.NextLink" title="View the next page">&rarr;</a>
            <% end_if %>
        </div>    
        <p>Page $Results.CurrentPage of $Results.TotalPages</p>
    </div>
    <% end_if %>
</div>