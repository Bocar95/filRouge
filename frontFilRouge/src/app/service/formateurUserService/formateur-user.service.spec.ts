import { TestBed } from '@angular/core/testing';

import { FormateurUserService } from './formateur-user.service';

describe('FormateurUserService', () => {
  let service: FormateurUserService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(FormateurUserService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
