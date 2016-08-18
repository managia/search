<div class="list-group">
    <div class="list-group-item" ng-repeat="item in result.suggests">
        <h4 class="list-group-item-heading">
            {{item.question}}
        </h4>
        <p class="list-group-item-text">
            {{item.answer}}
        </p>
    </div>
</div>
