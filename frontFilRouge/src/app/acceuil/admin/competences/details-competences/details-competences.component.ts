import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { CompetenceServiceService } from 'src/app/service/competenceService/competence-service.service';

@Component({
  selector: 'app-details-competences',
  templateUrl: './details-competences.component.html',
  styleUrls: ['./details-competences.component.css']
})
export class DetailsCompetencesComponent implements OnInit {

  element = [];
  niveaux = [];
  grpCompetences;
  snapshot: RouterStateSnapshot;
  url: string;
  id = [];
  toDetails: number;
  i = 0;
  j = 0;
  elseResponse = 'Il n\'y a pas encore de niveaux dédier à ce compétence.';

  constructor(
    private competenceService: CompetenceServiceService,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.toDetails = this.getIdOnUrl();
    this.competenceService.getById(this.toDetails).subscribe(
      (res: any) => {
        this.element = res;
        this.niveaux = this.element["niveauCompetences"];
        console.log(this.element);
      }
    );
  }

  getIdOnUrl() {
    this.snapshot = this.router.routerState.snapshot;
    this.url = this.snapshot['url'];
    this.id = this.url.split('/');
    return this.id[4];
  }

  reloadCurrentRoute() {
    let currentUrl = this.router.url;
    return this.router.navigateByUrl('/', {skipLocationChange: true}).then(() => {
        this.router.navigate([currentUrl]);
    });
  }

}
