<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
    <% cached 'generic-page', $Top.ID %>
    <article>
        <h1>$Title</h1>
        <div class="content">
            $BlockArea(Content)
        </div>
    </article>
    <% end_cached %>
        $Form
        $CommentsForm
</div>
