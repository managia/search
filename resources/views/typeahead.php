<script type="text/ng-template" id="customTemplate.html">
    <a>
    <img ng-src="http://upload.wikimedia.org/wikipedia/commons/thumb/{{match.model.flag}}" width="16">
    <span ng-bind-html="match.label | uibTypeaheadHighlight:query"></span>
    </a>
</script>

<script type="text/ng-template" id="typehead-popup.html">
    <div class="custom-popup-wrapper"
    ng-style="{top: position().top+'px', left: position().left+'px'}"
    style="display: block;"
    ng-show="isOpen() && !moveInProgress"
    aria-hidden="{{!isOpen()}}">
    <p class="message">select location from drop down.</p>

    <ul class="dropdown-menu" role="listbox">
    <li class="uib-typeahead-match" ng-repeat="match in matches track by $index" ng-class="{active: isActive($index) }"
    ng-mouseenter="selectActive($index)" ng-click="selectMatch($index)" role="option" id="{{::match.id}}">
    <div uib-typeahead-match index="$index" match="match" query="query" template-url="templateUrl"></div>
    </li>
    </ul>
    </div>
</script>