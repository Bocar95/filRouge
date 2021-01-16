import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ApprenantUserComponent } from './apprenant-user.component';

describe('ApprenantUserComponent', () => {
  let component: ApprenantUserComponent;
  let fixture: ComponentFixture<ApprenantUserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ApprenantUserComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ApprenantUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
