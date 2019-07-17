/*
 * Copyright (c) 2018 OBiBa. All rights reserved.
 *
 * This program and the accompanying materials
 * are made available under the terms of the GNU Public License v3.0.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


mica.obibaSearchFilter = angular.module('mica.obibaSearchFilter', [
  'obiba.mica.search'
])
  .run()
  .config(['ngObibaMicaSearchProvider', 'ngObibaMicaSearchTemplateUrlProvider',
    function (ngObibaMicaSearchProvider, ngObibaMicaSearchTemplateUrlProvider) {

      // technique to override the default obiba mica angular app templates (Not all component templates are overridable)
      if(Drupal.settings.listOverrideThemes){
        angular.forEach(Drupal.settings.listOverrideThemes, function (template, keyTemplate) {
          ngObibaMicaSearchTemplateUrlProvider.setTemplateUrl(keyTemplate, Drupal.settings.basePath + 'obiba_mica_app_angular_view_template/' + template);
        })
      }

    ngObibaMicaSearchProvider.initialize(Drupal.settings.obibaSearchFilterearchOptions);
  }])
  .directive('filterSearchInputWidget', [function () {
    return {
      restrict: 'EA',
      transclude: true,
      replace: true,
      scope: {
        type: '='
      },
      controller: 'filterSearchInputWidgetController',
      templateUrl: Drupal.settings.basePath + 'obiba_mica_app_angular_view_template/filter-name-search-widget'
    };
  }])
  .controller('filterSearchInputWidgetController', ['$scope', '$rootScope', '$location', 'RqlQueryService', 'ngObibaMicaUrl',
    function ($scope, $rootScope, $location, RqlQueryService, ngObibaMicaUrl) {
      function initMatchInput() {
        $scope.query = $location.search().query;
        $scope.target = 'variable';
        $scope.rqlQuery = RqlQueryService.parseQuery($scope.query);
      }


      $scope.urlRebuildLink = function () {
        initMatchInput();
        var rqlVarTarget = RqlQueryService.findTargetQuery('variable', $scope.rqlQuery);
        var baseRql = null;
        if(rqlVarTarget) {
          // get the base Rql (without any filter match)
          baseRql = rqlVarTarget.args.filter(function (arg) {
            return arg.name !== 'filter';
          });
        }
          if($scope.namesVar && $scope.namesVar.length > 0){
            var rql;
            var newMachRqlArg =  new RqlQuery(RQL_NODE.MATCH).push(encodeURI($scope.namesVar));
            if(baseRql){
              //rebuild the rql adding a filter match bucket
              baseRql.push(new RqlQuery(RQL_NODE.FILTER).push(newMachRqlArg));
              rql = new RqlQuery().serializeArgs(baseRql)
            }
            else{
              rql = new RqlQuery().serializeArgs(new RqlQuery(RQL_NODE.FILTER).push(newMachRqlArg))
            }
          }

          //return the new URl
          return ngObibaMicaUrl.getUrl('BaseUrl') + 'mica/search-filter/' +
            '#search?query=variable(' +
            (rql) +
            ')'


      };

       initMatchInput();
    }])
;
