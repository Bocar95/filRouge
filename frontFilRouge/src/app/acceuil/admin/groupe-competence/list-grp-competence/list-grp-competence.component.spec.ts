import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListGrpCompetenceComponent } from './list-grp-competence.component';

describe('ListGrpCompetenceComponent', () => {
  let component: ListGrpCompetenceComponent;
  let fixture: ComponentFixture<ListGrpCompetenceComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ListGrpCompetenceComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ListGrpCompetenceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
