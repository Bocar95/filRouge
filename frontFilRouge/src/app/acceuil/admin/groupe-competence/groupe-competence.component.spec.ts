import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GroupeCompetenceComponent } from './groupe-competence.component';

describe('GroupeCompetenceComponent', () => {
  let component: GroupeCompetenceComponent;
  let fixture: ComponentFixture<GroupeCompetenceComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ GroupeCompetenceComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(GroupeCompetenceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
