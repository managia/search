<div class="list-group">
    <div class="list-group-item"
         ng-repeat="(index, item) in result.suggests"
         ngclipboard 
         data-clipboard-text="{{item.answer}}"
         ngclipboard-success="onClipboardSuccess(e);"         
         role="button" title="Copy to clipboard">
        <h4 class="list-group-item-heading">
            {{item.question}}
        </h4>
        <p class="list-group-item-text" ng-bind-html="item.markedAnswer" add-clipboard-event>
            {{ item.markedAnswer }}
        </p>
    </div>
</div>
