<div class="all-results">
<div class="list-group-popular">
    <div class="list-group-item"
         ng-repeat="(index, item) in result.popular"
         ngclipboard 
         data-clipboard-text="{{item.answer}}"
         ngclipboard-success="onClipboardSuccess(e);"         
         role="button" title="Copy to clipboard">
        <h4 class="list-group-item-heading">
            {{item.question}}
        </h4>
        <p class="list-group-item-text" ng-bind-html="item.answer" add-clipboard-event>
            {{ item.answer }}
        </p>
    </div>
</div>
</div>