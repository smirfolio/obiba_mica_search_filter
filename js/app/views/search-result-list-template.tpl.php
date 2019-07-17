<?php
/**
 * Copyright (c) 2018 OBiBa. All rights reserved.
 *
 * This program and the accompanying materials
 * are made available under the terms of the GNU Public License v3.0.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @file
 * Code for the obiba_mica_obiba_mica_search_filter module.
 */

?>

<!--
  ~ Copyright (c) 2018 OBiBa. All rights reserved.
  ~
  ~ This program and the accompanying materials
  ~ are made available under the terms of the GNU Public License v3.0.
  ~
  ~ You should have received a copy of the GNU General Public License
  ~ along with this program.  If not, see <http://www.gnu.org/licenses/>.
  -->

<div ng-show="display === 'list'" class="list-table">
  <filter-search-input-widget></filter-search-input-widget>
  <div class="clearfix"></div>
  <hr />
  <result-tabs-order-count options="options" result-tabs-order="resultTabsOrder" active-target="activeTarget" target-type-map="targetTypeMap">
  </result-tabs-order-count>
  <div class="voffset2" ng-class="{'pull-right': options.studies.showSearchTab, 'pull-left': !options.studies.showSearchTab, 'hoffset2': !options.studies.showSearchTab}">
    <div class="btn-group" ng-if="type=='variables' && options.variables.showCart && (userCanCreateCart && userCanCreateSets)">
      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-cart-plus"></i> <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li><a ng-if="userCanCreateCart" ng-click="addToCart(type)" href translate>sets.add.button.cart-label</a></li>
        <li><a ng-if="userCanCreateSets" ng-click="addToSet(type)" href>{{'sets.add.button.set-label' | translate}}</a></li>
      </ul>
    </div>
    <a ng-click="addToSet(type)" target="_self" ng-if="type=='variables' && options.variables.showCart && !userCanCreateCart && userCanCreateSets" download class="btn btn-success"
       href>
      <i class="fa fa-cart-plus"></i>
    </a>
    <a ng-click="addToCart(type)" target="_self" ng-if="type=='variables' && options.variables.showCart && userCanCreateCart && !userCanCreateSets" download class="btn btn-success"
       href>
      <i class="fa fa-cart-plus"></i>
    </a>

    <a obiba-file-download url="getStudySpecificReportUrl()" target="_self" ng-if="type=='studies'" download class="btn btn-info"
       href>
      <i class="fa fa-download"></i> {{'report-group.study.button-name' | translate}}
    </a>
    <a obiba-file-download get-url="getSelectionsReportUrl()" target="_self" download class="btn btn-info" href>
      <i class="fa fa-download"></i> {{'download' | translate}}
    </a>
  </div>

  <div class="clearfix" ng-if="options.studies.showSearchTab"></div>

  <div class="tab-content">
    <div class="pull-left" study-filter-shortcut ng-if="options.studies.showSearchTab && options.studies.studiesColumn.showStudiesTypeColumn"></div>
    <div ng-repeat="res in resultTabsOrder" ng-show="activeTarget[targetTypeMap[res]].active" class="pull-right voffset2" test-ref="pager">
      <search-result-pagination
        show-total="true"
        target="activeTarget[targetTypeMap[res]].name"
        on-change="onPaginate(target, from, size, replace)"></search-result-pagination>
    </div>
    <div class="clearfix"></div>
    <ng-include include-replace ng-repeat="res in resultTabsOrder" src="'search/views/search-result-list-' + res + '-template.html'"></ng-include>
  </div>
</div>