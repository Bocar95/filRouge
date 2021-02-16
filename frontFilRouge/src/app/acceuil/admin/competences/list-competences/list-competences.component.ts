import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { CompetenceServiceService } from 'src/app/service/competenceService/competence-service.service';
import { GroupeCompetenceService } from 'src/app/service/groupeCompetenceService/groupe-competence.service';

@Component({
  selector: 'app-list-competences',
  templateUrl: './list-competences.component.html',
  styleUrls: ['./list-competences.component.css']
})
export class ListCompetencesComponent implements OnInit {

  competences = [];
  competencesList = [];
  grpCompetencesList = [];
  grpCompetences = [];
  niveaux = [];
  niveauxList = [];
  snapshot: RouterStateSnapshot;
  id = [];
  url: string;
  index: number = null;
  selectedGroupe = {'libelle': 'Groupe de compétence'};
  selectedCompetence;

  constructor(
    private competenceService: CompetenceServiceService,
    private router: Router,
    private groupeCompetenceService : GroupeCompetenceService
  ) { }

  ngOnInit(): void {
    this.competenceService.getCompetences().subscribe(
      (data : any) => {
        this.competences = data,
        console.log(data)
      }
    );
    this.groupeCompetenceService.getGrpCompetences().subscribe(
      (grpCompData : any) => {
        this.grpCompetencesList = grpCompData,
        console.log(grpCompData)
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

  onClickCompetence(id){
    return this.competenceService.getGrpCompetenceOfCompById(id).subscribe(
      (grpCompetenceData:any) => {
        this.grpCompetences = grpCompetenceData["groupeCompetences"],
        this.niveaux = grpCompetenceData["niveauCompetences"],
        console.log(this.grpCompetences),
        console.log(this.niveaux)
      }
    );
  }

  onClickGrpCompetence(id){
    return this.groupeCompetenceService.getCompetencesOfGrpCompetenceById(id).subscribe(
      (competenceData:any) => {
        this.competencesList = competenceData["competences"],
        this.niveauxList = competenceData["niveauCompetences"],
        console.log(this.competencesList),
        console.log(this.niveauxList)
      }
    );
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
