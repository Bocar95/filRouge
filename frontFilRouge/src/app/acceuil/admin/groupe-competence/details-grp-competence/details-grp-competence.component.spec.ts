import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetailsGrpCompetenceComponent } from './details-grp-competence.component';

describe('DetailsGrpCompetenceComponent', () => {
  let component: DetailsGrpCompetenceComponent;
  let fixture: ComponentFixture<DetailsGrpCompetenceComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DetailsGrpCompetenceComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DetailsGrpCompetenceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
