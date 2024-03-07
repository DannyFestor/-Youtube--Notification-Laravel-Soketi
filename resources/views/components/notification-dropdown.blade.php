<ol class="list-decimal">
    <template x-for="notification in notifications" x-bind:key="notification.id">
        <li x-text="notification.title"></li>
    </template>
</ol>
