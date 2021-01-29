import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { ReferentielService } from 'src/app/service/referentielService/referentiel.service';

@Component({
  selector: 'app-plus-de-details-ref-grp-comp',
  templateUrl: './plus-de-details-ref-grp-comp.component.html',
  styleUrls: ['./plus-de-details-ref-grp-comp.component.css']
})
export class PlusDeDetailsRefGrpCompComponent implements OnInit {

  competences = [];
  snapshot: RouterStateSnapshot;
  url: string;
  id = [];
  firstId : number;
  secondId : number;
  i = 0;
  j = 0;
  elseResponse = 'Il n\'y a pas encore de competences dédier à ce groupe de competence.';

  constructor(
    private referentielService: ReferentielService,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.firstId = this.getFirstIdOnUrl();
    this.secondId = this.getSecondIdOnUrl();
    this.referentielService.getCompOfGrpCompByIdOfRefById(this.firstId, this.secondId).subscribe(
      (res: any) => {
        this.competences = res
      }
    );
  }

  getFirstIdOnUrl() {
    this.snapshot = this.router.routerState.snapshot;
    this.url = this.snapshot['url'];
    this.id = this.url.split('/');
    return this.id[4];
  }

  getSecondIdOnUrl() {
    this.snapshot = this.router.routerState.snapshot;
    this.url = this.snapshot['url'];
    this.id = this.url.split('/');
    return this.id[6];
  }

}
