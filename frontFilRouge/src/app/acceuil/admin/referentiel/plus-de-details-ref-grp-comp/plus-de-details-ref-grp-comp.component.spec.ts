import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PlusDeDetailsRefGrpCompComponent } from './plus-de-details-ref-grp-comp.component';

describe('PlusDeDetailsRefGrpCompComponent', () => {
  let component: PlusDeDetailsRefGrpCompComponent;
  let fixture: ComponentFixture<PlusDeDetailsRefGrpCompComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PlusDeDetailsRefGrpCompComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PlusDeDetailsRefGrpCompComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
