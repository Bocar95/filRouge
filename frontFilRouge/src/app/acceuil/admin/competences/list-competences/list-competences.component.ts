import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { CompetenceServiceService } from 'src/app/service/competenceService/competence-service.service';

@Component({
  selector: 'app-list-competences',
  templateUrl: './list-competences.component.html',
  styleUrls: ['./list-competences.component.css']
})
export class ListCompetencesComponent implements OnInit {

  competences = [];
  btnAjouter = "Ajouter";
  btnNewCompetence = "Nouveau";
  btnModifier = "Modifier";
  btnSupprimer = "Supprimer";
  snapshot: RouterStateSnapshot;
  id = [];
  url: string;

  constructor(
    private competenceService: CompetenceServiceService,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.competenceService.getCompetences().subscribe(
      (data : any) => {
        this.competences = data,
        console.log(data)
      }
    )
  }

  getIdOnUrl() {
    this.snapshot = this.router.routerState.snapshot;
    var url: string;
    url = this.snapshot['url'];
    this.id = url.split('/');
    return this.id[4];
  }

  reloadComponent() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    this.router.navigate(['/acceuil/liste/competences']);
  }

  confirmModalNo() {
    return this.reloadComponent();
  }

  currentRoute() {
    var split;
    this.snapshot = this.router.routerState.snapshot;
    this.url = this.snapshot['url'];
    split = this.url.split('/');
    if((split[5] == `modifier`) || (split[5] == `details`)) {
      return true;
    }
    return false;
  }

  onClickBtnDetails(toLoad) {
    this.reloadComponent();
    return this.router.navigate([`/acceuil/liste/competences/${toLoad}/details`]);
  }

  onClickBtnPut(id) {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    return this.router.navigate([`/acceuil/liste/competences/${id}/modifier`]);
  }

  onClickBtnDelete() {
    var toDelete: number;
    toDelete = this.getIdOnUrl();
    console.log(toDelete);
     return this.competenceService.deleteCompetence(toDelete).subscribe(
      (res: any) => { 
        
        console.log(res)
      }
    ),this.reloadComponent();
  }
}
