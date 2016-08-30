<div class="list-group">
    <div class="list-group-item"
         ng-repeat="(index, item) in result.suggests"
         ngclipboard data-clipboard-text="{{item.answer}}"
         ngclipboard-success="onClipboardSuccess(e);"
         role="button" title="Copy to clipboard">
        <h4 class="list-group-item-heading">
            {{item.question}}
        </h4>
        <p class="list-group-item-text">
            {{item.answer}}
        </p>
    </div>
</div>
