import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetailsCompetencesComponent } from './details-competences.component';

describe('DetailsCompetencesComponent', () => {
  let component: DetailsCompetencesComponent;
  let fixture: ComponentFixture<DetailsCompetencesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DetailsCompetencesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DetailsCompetencesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
